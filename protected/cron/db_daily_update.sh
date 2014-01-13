#!/bin/sh
mysql -uwcadmin -p123 -e"use wcptf_dev;update products set products.daily_instore=products.instore where products.deleted<>1;"