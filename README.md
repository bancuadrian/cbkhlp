## Requirements
```
php > 7.4
node > 14
npm > 6
```
## Running the app
```
git clone git@github.com:bancuadrian/cbkhlp.git
cd cbkhlp
make build-and-run
```

## Login

While building, data is seeded so you won't have to Login with the following email / password combinations:

* user1@example.com / password
* user2@example.com / password

Go to http://127.0.0.1:8000/login and login or http://127.0.0.1:8000/register to register

## API Tokens

To generate API Tokens, go to http://127.0.0.1:8000/user/api-tokens and generate a token.

You can then use the following requests:

Get current user
```
curl --request GET \
  --url http://127.0.0.1:8000/api/user \
  --header 'Authorization: Bearer Bg1PBOONfClJ0pr3EAkaYOcXSSNEx9GChLklP5bo'
```

Get all books with filter, sorting and pagination
```
curl --request GET \
  --url 'http://127.0.0.1:8000/api/books?title=she&sort%5Bby%5D=author_id&sort%5Border%5D=asc' \
  --header 'Authorization: Bearer sma6ClJu6H6AGMD4Hv5j7JIP6kWZVH146NPkQULT'
```

Get book by id
```
curl --request GET \
  --url http://127.0.0.1:8000/api/books/16 \
  --header 'Authorization: Bearer reXHlgjI7nlrcxuwzJBojYBQwm0qmEQWGDyDd4N2'
```

