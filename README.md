### Simple Blog Using Symfony 4

Simple Blog enable to Users(even without login) display Articles and comments on every article,
every article has categories classified it also User can filter articles according to category which article setting under(one category only),
Blog include Admin facilities to enable add new Article. 

Blog include vagrant box to Run Example, To install vagrant [See official Doc](https://www.vagrantup.com/downloads.html) you must install virtualBox first [See official Doc](https://www.virtualbox.org/wiki/Downloads).

Template Used in Login example Download from [colorlib.com](https://colorlib.com/wp/template/callie/).

To access blog's source code under `application` folder.

Simple Blog's technologies stack: `Symfony`, `MySQL`, `Doctrine` and `Twig`

##### To Run Simple Blog:

- load vagrant box with next command
```
cd /project-path && vagrant up
```

- install application dependencies with Composer
```
vagrant ssh
cd /vagrant/application/ && composer install
```

- open any browser with next path => http://192.168.45.3/

##### Possible Routes (can navigate all pages using menu button)

- Index route for Blog Home page => http://192.168.45.3/
 
- List all Articles page => http://192.168.45.3/articles/

- List all Categories page =>  http://192.168.45.3/categories/
 
- Article's full page => http://192.168.45.3/article/:article-id

- Login page => http://192.168.45.3/login/

- Add new article (only after user login and user is admin) => http://192.168.45.3/article/add/

- Add new comment under specific article (only after user login) => http://192.168.45.3/article/:article-id/comment/add/

- Logout page => http://192.168.45.3/logout/

##### Database:

MySQL Database for Simple Blog include 5 tables structure 

- **Users** include users details(access credentials) plus every user's role

- **Articles** include articles details

- **Categories** include categories details [master table]

- **Article_Comments** include comments details on every article

- **Article_Categories** include categories which every article has been setting under

Also this tables have some dummy data for Test, So There Two User Already exists

- User with username: **ahmed@test.com** and password: **user123098**

- Admin with username: **admin@test.com** and password: **admin123098**

To Access Full MySQL file for this database from => `vagrant/sql/aqarmapTaskDB.sql.gz`   

##### Notices:

- To access example code on vagrant box using SSH with next command
```
cd /project-path && vagrant ssh
cd /vagrant/application/
```

- To Install Blog's packages dependencies[back-end packages]
```
cd /project-path && vagrant ssh
cd /vagrant/application/
composer install
```
