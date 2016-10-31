#!/bin/bash
composer install
#bower install
#compass compile -c config.rb  --sass-dir web/sass/ --css-dir web/stylesheets/ --image-dir web/images/
./propel config:convert --output-dir=src --output-file=propel-config.php
./propel sql:insert
