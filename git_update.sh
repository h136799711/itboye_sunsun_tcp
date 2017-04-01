#git 更新test456789
#pull的情况是正式环境下用pull，测试环境用fetch
git fetch origin master | get reset --hard master | composer update