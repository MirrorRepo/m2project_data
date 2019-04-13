VERSION 1.2.0:
- Update GDPR extension
- Fix builder issue

If you are new, please ignore this patch.
Please follow our steps to update:
- upload app folder to your magento root folder
- remove generated/code
- remove var/*
- remove pub/static/frontend/Mgs
- enable GDPR extension: php bin/magento module:enable MGS_GDPR
- run upgrade command: php bin/magento setup:upgrade
- run deploy command: php bin/magento setup:static-content:deploy -f