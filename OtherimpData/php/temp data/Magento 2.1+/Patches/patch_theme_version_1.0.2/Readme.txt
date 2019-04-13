VERSION 1.0.2:
- Change the way to call custom css
- Fix issue import homepage

If you are using old version and want to update from version 1.0.1 to version 1.0.2, please follow our steps:
- upload app folder to your magento root folder
- remove var/*
- run deploy command: php bin/magento setup:static-content:deploy
- go to admin > MGS > [MGS Theme] Theme Setting and "Save Config" again.

If you are new. Please ignore this patch.