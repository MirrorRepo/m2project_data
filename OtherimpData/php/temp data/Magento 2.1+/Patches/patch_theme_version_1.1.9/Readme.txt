VERSION 1.1.9:
- Add Layered Navigation extension
- Fix sidebar button issue on IOS
- Fix ACL issue for megamenu and testimonial
- Improve code (remove objectmanager in template)

If you are new, please ignore this patch.
Please follow our steps to update:
- upload app folder to your magento root folder
- remove generated/code
- remove var/*
- remove pub/static/frontend/Mgs
- enable Layered Navigation extension: php bin/magento module:enable MGS_Ajaxlayernavigation
- run upgrade command: php bin/magento setup:upgrade
- run deploy command: php bin/magento setup:static-content:deploy -f