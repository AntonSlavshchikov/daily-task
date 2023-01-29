## Dayli-task

Приложение предназначено для формирования списка задач каждому пользователю на каждый день. 

**Основные функции приложения:**
- Регистрация пользователя
- Авторизация пользователя
- Получение списка задач авторизированного пользователя
- Отметка определенной задачи о ее выполнении
- Замена задачи
- Ежедневное формирование нового уникального списка задач

## Начало работы

Чтобы начать использовать данное приложение, нужно клонировать репозиторий, установить все зависимости прописав команду: <br/>
`composer install` <br/>
После нужно сформировать `.env` файл с параметрами, а также параметрами подключения к базе данных и провести миграции с помощью команды:<br/>
`php artisan migrate`<br/>
В данном приложении присутствуют ФАБРИКИ, которые генерируют фейковые данные для начала работы и проверки функционала приложения. Чтобы их сгенерировать, нужно запустить команду:<br/>
`php artisan db:seed`<br/>
После ее выполнения сгенерируется тестовый пользователь "test@test.com" с паролем "325478", а так же категории задач и 10 задач для тестового пользователя.
## Примечание
Все ответы по задачам возвращаются в json формате, который имеет структуру:
```json
{
    "data": {
        "id": "ID ЗАДАЧИ",
        "type": "ТАБЛИЦА В БД",
        "attributes": { 
            "title": "НАИМЕНОВАНИЕ ЗАДАЧИ",
            "isReady": "СТАТУС ЗАДАЧИ",
            "user_id": "КАКОМУ ПОЛЬЗОВАТЕЛЮ ПРИНАДЛЕЖИТ ЗАДАЧА"
        },
        "relationships": {
            "category": {
                "id": "ID КАТЕГОРИИ",
                "type": "ТАБЛИЦА БД",
                "attributes": {
                    "title": "НАИМЕНОВАНИЕ КАТЕГОРИИ"
                },
                "relationships": ["СВЯЗИ С ДРУГИМИ РЕСУРСАЛИ"],
                "appends": ["ДОПОЛНИТЕЛЬНЫЕ ДАННЫЕ"]
            }
        },
        "appends": {
            "date": "29.01.2023"
        }
    }
}
```
## Функционал

**API роуты для выполнения задач:**
- POST: /api/register
- POST: /api/login
- POST: /api/logout
- Create
- GET: /api/task/getAll
- POST: /api/task/update/{id}
- POST: /api/task/replace/{id}

Теперь о каждом по подробнее:

### POST: /api/register
Функция для регистрации пользователя. Принимает в тело запроса такие параметры как: `name, password, email`
После того, как пользователь ввел свои данные и отправил запрос, функция вернет ответ в виде токена доступа
```json
{
  "data": {
    "token": "your_auth_token"
  }
}
```
Который в дальнейшем будет использоваться для проверки авторизации пользователя, если токена не будет, то и запросы будут возвращать соответствующую ошибку
```json
{
  "message": "Unauthenticated."
}
```

### POST: /api/login
Функция для аутентификации пользователя. Принимает в тело запроса такие параметры как: `email, password`
После того, как пользователь ввел свои данные и отправил запрос, функция вернет токен доступа
```json
{
  "data": {
    "token": "your_auth_token"
  }
}
```
Который в дальнейшем будет использоваться для проверки авторизации пользователя, если токена не будет, то и запросы будут возвращать соответствующую ошибку
```json
{
  "message": "Unauthenticated."
}
```

### POST: /api/logout
Функция для выхода из системы. При ее выполненни программа отзывает токены авторизации пользователя.
Результат выполнения функции - это json сообщение о том, что пользователь покинул систему.
```json
{
    "data": {
        "message": "You are successfully logged out"
    }
}
```

### Create
Функция предназначена для формирования уникального списка задач для определенного пользователя.
Запускается она в планировщике задач, что бы запустить планировщик локально, нужно выполнить команду:<br/>
`php artisan schedule:test` - выполнить команду мгновенно, но сначала появится список с запланированными задачами
из которого нужно выбрать соответствующий, в данном случае под цифрой "0" так как задача всего одна.<br/>
`php artisan schedule:work` - запустит локально планировщик задач, который будет выполнять функцию каждый день

### <span style="color:red">!ВАЖНО!</span>
Дальнейшии функции выполняются будучи авторизированным, чтобы небыло ошибок и иметь доступ к функциям нужно 
добавить 2 заголовка:<br/>
`Accept: application/json`<br/>
`Authorization: Bearer your_token`

### GET: /api/task/getAll
<span style="color:orange">**Данная функция выполняется будучи авторизированным**</span><br/>
Функция которая возвращает список задач для текущего пользователя. При ее выполнении возвращается результат в виде json:
```json
{
  "data": [
      {
          "id": 1,
          "type": "tasks",
          "attributes": {
              "title": "Nihil quia qui sit reiciendis sit. Aut ex laboriosam est nulla sit.",
              "isReady": 0,
              "user_id": 1
          },
          "relationships": {
              "category": {
                  "id": 5,
                  "type": "category_tasks",
                  "attributes": {
                      "title": "Performance"
                  },
                  "relationships": [],
                  "appends": []
              }
          },
          "appends": {
              "date": "29.01.2023"
          }
      }
  ]
}
```

### POST: /api/task/update/{id}
<span style="color:orange">**Данная функция выполняется будучи авторизированным**</span><br/>
Функция которая отмечает задачу как выполненную по id  и возвращает ее в json формате
```json
{
  "data": [
      {
          "id": 1,
          "type": "tasks",
          "attributes": {
              "title": "Nihil quia qui sit reiciendis sit. Aut ex laboriosam est nulla sit.",
              "isReady": 1,
              "user_id": 1
          },
          "relationships": {
              "category": {
                  "id": 5,
                  "type": "category_tasks",
                  "attributes": {
                      "title": "Performance"
                  },
                  "relationships": [],
                  "appends": []
              }
          },
          "appends": {
              "date": "29.01.2023"
          }
      }
  ]
}
```

### POST: /api/task/replace/{id}
<span style="color:orange">**Данная функция выполняется будучи авторизированным**</span><br/>
Функция которая заменяет задачу по id и возвращает замененную задачу в json формате.

```json
{
    "data": {
        "id": 2906,
        "type": "tasks",
        "attributes": {
            "title": "654Xf36tRJwDo3RvKiEhOwn93YBowPnYoPCxAzQilDwdETmFUuwz6aJ7ycZQuMG0sGRGBjgorLJ0pVfuoH3hRPOLWF4rluefcrIE",
            "isReady": false,
            "user_id": 1
        },
        "relationships": {
            "category": {
                "id": 6,
                "type": "category_tasks",
                "attributes": {
                    "title": "Booleans"
                },
                "relationships": [],
                "appends": []
            }
        },
        "appends": {
            "date": "29.01.2023"
        }
    }
}
```
