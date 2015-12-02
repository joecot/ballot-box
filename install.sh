#!/bin/bash
composer install
bower install
compass compile -c resources/compass/config.rb  --sass-dir resources/compass/sass/ --css-dir web/css/ --image-dir web/images/
vendor/propel/propel/bin/propel config:convert --output-dir=src --output-file=propel-config.php
