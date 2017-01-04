Installation instructions
=========================

- `git clone https://github.com/betouarhamza/rest-server.git`
- `composer update`
- `php -S localhost:8000 public/index.php`

Configuration :
=========================
- Rename the file "database.php-example" to "database.php"
- Change the connection parameters to the database


Usage :
=========================
- Rename the file "database.php-example" to "database.php"
- Change the connection parameters to the database
- URLs :
    - Find All items : [GET] "/{table_name}"
        - example : `[GET] http://localhost:8000/post`
    - Find a item by id : [GET] "/{table_name}/{id}"
        - example : `[GET] http://localhost:8000/post/24`
    - Add new item : [POST] "/{table_name}"
        - example : `[POST] http://localhost:8000/post [request="title=New title;content=New content;created_at=2017-01-03 17:32:55"]`
    - Update a item : [POST, PUT] "/{table_name}/{id}"
        - example : `[POST, PUT] http://localhost:8000/post/7 [request="title=title edited;content=content edited"]`
    - Delete a item by id : [DELETE] "/{table_name}/{id}"
        - example : `[DELETE] http://localhost:8000/post/24`
