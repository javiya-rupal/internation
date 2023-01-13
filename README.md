# internation

An example RESTful API built on top of Symfony 5.4

## Features

- RESTful routing
- Entity with proper relationships
- Controllers/Repositories with proper separation of concerns
- RESTful errors

## Routes List:

### Groups

| Method     | URI                               | Action                                                  |
|------------|-----------------------------------|---------------------------------------------------------|
| `GET`      | `api/groups`                      | `App\Http\Controllers\GroupController@indexAction`      |
| `POST`     | `api/groups`                      | `App\Http\Controllers\GroupController@createAction`     |
| `DELETE`   | `api/groups/{id}`                 | `App\Http\Controllers\GroupController@deleteAction`     |

### Users

| Method     | URI                               | Action                                                  |
|------------|-----------------------------------|---------------------------------------------------------|
| `GET`      | `api/users`                       | `App\Http\Controllers\UserController@indexAction`       |
| `POST`     | `api/users`                       | `App\Http\Controllers\UserController@createAction`      |
| `DELETE`   | `api/users/{id}`                  | `App\Http\Controllers\UserController@deleteAction`      |


### Group Users

| Method     | URI                               | Action                                                     |
|------------|-----------------------------------|------------------------------------------------------------|
| `POST`     | `api/groupUser/assign`            | `App\Http\Controllers\UserController@assignGroupAction`    |
| `POST`     | `api/groupUser/remove`            | `App\Http\Controllers\UserController@removeGroupUserAction`|

### Documents

#### Domain Model
![Domain Model](https://github.com/javiya-rupal/internation/blob/master/docs/domain-model.jpg)

#### ER Diagram
![ER Diagram](https://github.com/javiya-rupal/internation/blob/master/docs/ER-Diagram.jpg)

## TODO

- Form submission validation for required field or submitted content type
- Authorization to access API
- Unit testing

