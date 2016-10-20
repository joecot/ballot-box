#!/bin/bash
ng build --dev && cp src/.htaccess ../web/.htaccess && cp src/index.php ../web/index.php
