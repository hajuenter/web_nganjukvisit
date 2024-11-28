<?php
$maintenanceConfig = require 'maintenance_access.php';
echo $maintenanceConfig['maintenance_mode'] ? 'on' : 'off';
