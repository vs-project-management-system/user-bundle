#Project Management System
##User Bundle
User bundle for the PMS System sandbox.

###Entities
- Admin
- Client
- Developer
- User

###Forms
- AdminFormType
- ClientFormType
- DeveloperFormType
- RegistrationFormType
- UserFormType

####Form Model
- Registration

###Routes
route name | path
--- | ---
pms_admin_edit | /admins/{slug}/edit
pms_admin_index | /admins
pms_admin_new | /admins/new
pms_admin_remove | /admins/{slug}/remove
pms_admin_show | /admins/{slug}

###Repositories
- AdminRepository
- ClientRepository
- DeveloperRepository
- UserRepository

###Resources
Action | Template
--- | ---
edit | edit.html.twig
index | index.html.twig
new | new.html.twig
remove | remove.html.twig
show | show.html.twig
