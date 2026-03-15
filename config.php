<?php
$hostname = "localhost";
$username = "gecodini_gecodini";
$password = "z0gR^bA{e)rl";
$database = "gecodini_gecoddatabase";
if (!defined('base_url')) define('base_url', 'https://gecodinitiative.org/');

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fallback json_encode/json_decode for servers missing the JSON extension
if (!function_exists('json_encode')) {
    function json_encode($val) {
        if (is_null($val))    return 'null';
        if (is_bool($val))    return $val ? 'true' : 'false';
        if (is_int($val) || is_float($val)) return $val;
        if (is_string($val))  return '"' . str_replace(['"','\\',"\n","\r","\t"], ['\\"','\\\\','\\n','\\r','\\t'], $val) . '"';
        if (is_array($val)) {
            $keys = array_keys($val);
            $isObj = ($keys !== array_keys($keys));
            $parts = array();
            foreach ($val as $k => $v) {
                $parts[] = $isObj ? ('"' . $k . '":' . json_encode($v)) : json_encode($v);
            }
            return $isObj ? '{' . implode(',', $parts) . '}' : '[' . implode(',', $parts) . ']';
        }
        return 'null';
    }
}
if (!function_exists('json_decode')) {
    function json_decode($str, $assoc = false) { return null; }
}
