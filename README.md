# Login system for codeigniter. ToAdd: Tracking, sql, various

added recently:
 - nested set demo
 - permissions framework
 - secure login
 - email validation
 - minor fixes

todo:
 - permissions per post e.g only friends can see this, private for me, anyone but friends can see this
 - admin panel - change perms
 - different usertypes:
 --- normal user with profile
 ------ can own vouchers of many manufacturers
 --- company
 ------ can edit/disable/own vouchers
 --- moderator
 --- superadmin
 - adapt nested sets
 - vouchers
 - tomo
 - profiles
 - investigate chat
 - Ajax form validation
 - capcha
 - password confirmation
 - email confirmation
 - user groups

 user_groups
*perm_type
group_name


user_perms
*user_id
perm_type

nested sets

vouchers:

*voucher_id
voucher_title
voucher_description
voucher_worth
voucher_status
voucher_parent

voucher_categories:
category_id

