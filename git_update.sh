#pull的情况是正式环境下用pull，测试环境用fetch
git fetch origin master && git reset --hard origin/master && composer update --no-dev && composer dump-autoload --optimize