<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
include 'libAyra.php';
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    //code 1
    protected function setSuccessResponse($data = [], $message=NULL, $message_code=NULL, $api_token=NULL, $message_action=NULL)
    {
        return response()->json([
            "data" => $data,
            "api_token" => $api_token,
            "log" => '',
            "code" => 200,
            "message" => $message,
            "message_code" => $message_code,
            "message_action" => $message_action,
            "status" => 1,
            'APIVersion' => 1
        ]);
    }
    //code  2
    protected function setWarningResponse($data = [], $message=NULL, $message_code=NULL, $api_token=NULL, $message_action=NULL)
    {
        return response()->json([
            "data" =>$data,
            "api_token" => '',
            "log" => '',
            "code" => 200,
            "message" => $message,
            "message_code" => $message_code,
            "message_action" => $message_action,
            "status" => 0,
            'APIVersion' => 1
        ]);
    }
    protected function setErrorResponse($message_code = 'ERROR', $message_action=NULL)
    {
        $message = "";
        if (is_array($message_code)) {
            foreach ($message_code as $msg) {
                $message = $msg;
            }

            $message_code = implode(',', $message_code);
        } else {
            $message = $message_code;
        }

        return response()->json([
            "data" => '', //this will be for data
            "api_token" => '', //this is hold token after success login
            "log" => '', //provide log id
            "code" => 200, //response code
            "message" => $message,
            "message_code" => $message_code,
            "message_action" => $message_action, //if any action requieed then suggest
            "status" => 0,
            'APIVersion' => 1
        ]);
    }
    

    protected function DataGridResponse($data = [], $columnsDefault = [])
    {
        if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
            $columnsDefault = [];
            foreach ( $_REQUEST['columnsDef'] as $field ) {
                $columnsDefault[ $field ] = true;
            }
        }
        
        // get all raw data
        //$alldata = json_decode( file_get_contents( '../datasource/default.json' ), true );
        $alldata=json_decode($data, true);
        
        $data = [];
        // internal use; filter selected columns only from raw data
        foreach ( $alldata as $d ) {
            $data[] = $this->filterArray( $d, $columnsDefault );
        }
        
        // count data
        $totalRecords = $totalDisplay = count( $data );
        
        // filter by general search keyword
        if ( isset( $_REQUEST['search'] ) ) {
            $data         = $this->filterKeyword( $data, $_REQUEST['search'] );
            $totalDisplay = count( $data );
        }
        
        if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
            foreach ( $_REQUEST['columns'] as $column ) {
                if ( isset( $column['search'] ) ) {
                    $data         = $this->filterKeyword( $data, $column['search'], $column['data'] );
                    $totalDisplay = count( $data );
                }
            }
        }
        
        // sort
        if ( isset( $_REQUEST['RecordID'][0]['column'] ) && $_REQUEST['RecordID'][0]['dir'] ) {
            $column = $_REQUEST['RecordID'][0]['column'];
            $dir    = $_REQUEST['RecordID'][0]['dir'];
            usort( $data, function ( $a, $b ) use ( $column, $dir ) {
                $a = array_slice( $a, $column, 1 );
                $b = array_slice( $b, $column, 1 );
                $a = array_pop( $a );
                $b = array_pop( $b );
        
                if ( $dir === 'asc' ) {
                    return $a > $b ? true : false;
                }
        
                return $a < $b ? true : false;
            } );
        }
        
        // pagination length
        if ( isset( $_REQUEST['length'] ) ) {
            $data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
        }
        
        // return array values only without the keys
        if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
            $tmp  = $data;
            $data = [];
            foreach ( $tmp as $d ) {
                $data[] = array_values( $d );
            }
        }
        
        $result = [
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalDisplay,
            'data'            => $data,
        ];
        
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        
        echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    }

    function filterArray( $array, $allowed = [] ) {
        return array_filter(
            $array,
            function ( $val, $key ) use ( $allowed ) { // N.b. $val, $key not $key, $val
                return isset( $allowed[ $key ] ) && ( $allowed[ $key ] === true || $allowed[ $key ] === $val );
            },
            ARRAY_FILTER_USE_BOTH
        );
    }
    
    function filterKeyword( $data, $search, $field = '' ) {
        $filter = '';
        if ( isset( $search['value'] ) ) {
            $filter = $search['value'];
        }
        if ( ! empty( $filter ) ) {
            if ( ! empty( $field ) ) {
                if ( strpos( strtolower( $field ), 'date' ) !== false ) {
                    // filter by date range
                    $data = filterByDateRange( $data, $filter, $field );
                } else {
                    // filter by column
                    $data = array_filter( $data, function ( $a ) use ( $field, $filter ) {
                        return (boolean) preg_match( "/$filter/i", $a[ $field ] );
                    } );
                }
    
            } else {
                // general filter
                $data = array_filter( $data, function ( $a ) use ( $filter ) {
                    return (boolean) preg_grep( "/$filter/i", (array) $a );
                } );
            }
        }
    
        return $data;
    }
    
    function filterByDateRange( $data, $filter, $field ) {
        // filter by range
        if ( ! empty( $range = array_filter( explode( '|', $filter ) ) ) ) {
            $filter = $range;
        }
    
        if ( is_array( $filter ) ) {
            foreach ( $filter as &$date ) {
                // hardcoded date format
                $date = date_create_from_format( 'm/d/Y', stripcslashes( $date ) );
            }
            // filter by date range
            $data = array_filter( $data, function ( $a ) use ( $field, $filter ) {
                // hardcoded date format
                $current = date_create_from_format( 'm/d/Y', $a[ $field ] );
                $from    = $filter[0];
                $to      = $filter[1];
                if ( $from <= $current && $to >= $current ) {
                    return true;
                }
    
                return false;
            } );
        }
    
        return $data;
    }
    
    
}
