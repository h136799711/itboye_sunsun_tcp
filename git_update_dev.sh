#pull的情况是正式环境下用pull，测试环境用fetch
git fetch origin dev && git reset --hard origin/dev  && composer dump-autoload --optimize