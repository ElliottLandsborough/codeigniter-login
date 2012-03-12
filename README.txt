added recently:
 - nested set demo
 - permissions framework
 - secure login
 - email validation
 - minor fixes
 - minify html - line 18 of tools/compress.php
 - minify js if need be - plugin installed
 - captcha - enable ~line 112  of controllers/user.php
 - password/email confirmation on registration

todo:
 - friends
 - search
 - admin panel - change perms
 - vouchers
 - adapt nested sets
 - profiles
 - edit profiles
 - user groups
 - post content

todo later:
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