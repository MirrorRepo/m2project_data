VERSION 1.1.2:
- Support for Ahead Works One Step checkout magento 2
- Fix ajaxcart issue

If you are using old version and want to update from version 1.1.1 to version 1.1.2, please follow our steps:
- upload app folder to your magento root folder
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy


If you are new. Please ignore this patch.