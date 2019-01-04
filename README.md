Blog application using Symfony 3.4
========================

the application allows user to sign in and start to write blog posts. They can then read other people's blog posts, and manage their own posts (edit or delete posts).

Used doctrine for database management using sqlite as driver in dev mode, and postgreSQL during production.
You access the app that's been deployed to heroku [here](https://lachguer-ali-blog.herokuapp.com/).


### FOSUserBundle
used for managing the sign up and log in of the application users.

### Knp/paginator
to paginate the applications posts in home page, each page is limited to 5 posts.

### slugify
to generate a slug for each new post, using the post's title.



