VERSION 1.2.2:
- Fix forgot password issue
- Fix register issue
- Fix issue message not show on homepage
- Fix ajax cart issue

If you are new, please ignore this patch.
Please follow our steps to update:
- upload app folder to your magento root folder
- remove app/design//frontend/Mgs/mgsblank/Magento_Customer/templates/form/register.phtml
- remove generated/code
- remove var/*
- remove pub/static/frontend/Mgs
- run deploy command: php bin/magento setup:static-content:deploy -f