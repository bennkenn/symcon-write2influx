# symcon-write2influx
IP-Syncom PHP function to write data into influx-db

## Installation
- Install Module from git
- Create new instance (Device) of influxwriter
- Configure the InfluxDB Server IP, Port and the database name in the properties of the new device.

## Usage
Module provides public function KC_write2influx($influxWriterModuleId, $id, $system, $category, $valuename)
#### Example
Example script to be added under the variable you like to write to your InfluxDB:
```php
$id = IPS_GetParent($_IPS['SELF']);
//Object Id of the symcon-write2influx Device
$influxWriterModuleId = 24750;
$system = 'Heizung';
$category = 'Waermepumpe';
$valuename = 'HeizstabStatus';
KC_write2Influx($influxWriterModuleId, $id, $system, $category, $valuename);
```
## License
[CC BY-NC-SA 4.0](https://creativecommons.org/licenses/by-nc-sa/4.0/) 
