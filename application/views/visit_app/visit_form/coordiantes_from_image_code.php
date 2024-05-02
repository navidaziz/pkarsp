function triphoto_getGPS($fileName)
{
// Get the EXIF metadata from the image
$exif = exif_read_data($fileName);

if (isset($exif["GPSLatitudeRef"])) {
$LatM = 1;
$LongM = 1;

// Determine the sign for latitude and longitude
if ($exif["GPSLatitudeRef"] == 'S') {
$LatM = -1;
}
if ($exif["GPSLongitudeRef"] == 'W') {
$LongM = -1;
}

// Get the GPS data
$gps['LatDegree'] = $exif["GPSLatitude"][0];
$gps['LatMinute'] = $exif["GPSLatitude"][1];
$gps['LatgSeconds'] = $exif["GPSLatitude"][2];
$gps['LongDegree'] = $exif["GPSLongitude"][0];
$gps['LongMinute'] = $exif["GPSLongitude"][1];
$gps['LongSeconds'] = $exif["GPSLongitude"][2];

// Get altitude data
$altitude = isset($exif["GPSAltitude"]) ? $exif["GPSAltitude"] : null;

// Convert strings to numbers
foreach ($gps as $key => $value) {
$pos = strpos($value, '/');
if ($pos !== false) {
$temp = explode('/', $value);
$gps[$key] = $temp[0] / $temp[1];
}
}

// Calculate the decimal degree for latitude and longitude
$result['latitude'] = $LatM * ($gps['LatDegree'] + ($gps['LatMinute'] / 60) + ($gps['LatgSeconds'] / 3600));
$result['longitude'] = $LongM * ($gps['LongDegree'] + ($gps['LongMinute'] / 60) + ($gps['LongSeconds'] / 3600));

// Add altitude to the result if available
if ($altitude !== null) {
$result['altitude'] = str_replace('/1', '', $altitude);
}

// Get datetime information
$result['datetime'] = $exif["DateTime"];

return $result;
}
}

$fileName = 'http://' . $_SERVER['HTTP_HOST'] . $input->picture_1;
$returned_data = triphoto_getGPS($fileName);
var_dump($returned_data);