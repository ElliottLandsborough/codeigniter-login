added recently:
 - nested set demo
 - permissions framework
 - secure login
 - email validation
 - minor fixes
 - minify html - line 18 of tools/compress.php
 - minify js if need be - plugin installed
 - captcha - enable ~line 86 of controllers/user.php
 - password/email confirmation on registration
 - nginx?

todo:
 - friends
 - search
 - vouchers
 - adapt nested sets
 - profiles
 - edit profiles
 - user groups
 - post content

todo later:
 - admin panel - change perms
 - Ajax form validation
 - chat - limit it to friends list
 - tomo
 - permissions per post e.g only friends can see this, private for me, anyone but friends can see this
 - db caching
 - tracking

vouchers:

*voucher_id
voucher_title
voucher_description
voucher_worth
voucher_parent
voucher_owner
voucher_category
voucher_perms

voucher_permissions:
PUBLIC 1
MEMBERS_ONLY 2

voucher_categories:
category_id
+nested set items

friends
*user_id
friend_id
accepted

Chat:
sudo start nodechat
sudo stop nodechat
tobegin monitoring to stop crashing - need to test:
monit -d 60 -c /etc/monit/monitrc
/etc/init.d/monit restart

/etc/init/nodechat.conf
/etc/monit/conf.d/nodechat.conf

See here: http://howtonode.org/deploying-node-upstart-monit

node install:
sudo apt-get update && apt-get install git-core curl build-essential openssl libssl-dev
git clone https://github.com/joyent/node.git
cd node
# 'git tag' shows all available versions: select the latest stable.
git checkout v0.6.8
# Configure seems not to find libssl by default so we give it an explicit pointer.
# Optionally: you can isolate node by adding --prefix=/opt/node
./configure --openssl-libpath=/usr/lib/ssl
make
make test
#NOT THIS: sudo make install
# dothis:
checkinstall -D make install
node -v # it's alive!
# Lucky us: NPM is packaged with Node.js source so this is now installed too
# curl http://npmjs.org/install.sh | sudo sh
npm -v # it's alive!