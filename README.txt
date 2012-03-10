currently fucked:
 - permlib.php
 half way through modularizing permlib.php and adapting it to work with all permission subsets and defaults
 getperms needs to run through and if the perms do not exist yet it needs to get the defaults from defaultperms and then use them to write the default perms in the table

added recently:
 - nested set demo
 - permissions framework
 - secure login
 - email validation
 - minor fixes
 - minify html - line 18 of tools/compress.php
 - minify js if need be - plugin installed

todo
 - db caching
 - tracking
 - permissions per post e.g only friends can see this, private for me, anyone but friends can see this
 - admin panel - change perms
 - adapt nested sets
 - vouchers
 - tomo
 - profiles
 - chat - http://www.bluejavax.com/gmailfacebook-like-chat-with-codeigniter/
 - Ajax form validation
 - captcha
 - password confirmation
 - email confirmation
 - user groups

vouchers:

*voucher_id
voucher_title
voucher_description
voucher_worth
voucher_status
voucher_parent

voucher_categories:
category_id