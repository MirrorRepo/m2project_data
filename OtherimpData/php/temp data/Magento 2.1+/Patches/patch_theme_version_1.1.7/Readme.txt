VERSION 1.1.7:
- Fix capcha issue on login popup
- Fix search issue on mobile

If you are new please ignore this patch.

To update this patch, please follow our steps:
- upload folder named app to your magento root folder
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy -f