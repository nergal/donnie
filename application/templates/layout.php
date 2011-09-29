<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{ title }} | Микрофреймворк для PHP 5.4</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!--[if lt IE 9]><script src="/js/html5.js"></script><![endif]-->

    <!-- Le styles -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style type="text/css">
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px;
      }
      .container > footer p {
        text-align: center;
      }
      .container {
        width: 820px;
      }

      .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px;
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }

      .content .span10,
      .content .span4 {
        min-height: 500px;
      }
      .content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
      }

      .topbar .btn {
        border: 0;
      }

    </style>

    <script type="text/javascript" src="/js/jquery-1.6.4.min.js"></script>

    <link rel="shortcut icon" href="/images/favicon.ico">
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="/">Donnie</a>
          <ul class="nav">
            <li class="active"><a href="/">О фреймворке</a></li>
            <li><a href="/contact/">Документация</a></li>
            <li><a href="/code/">Код</a></li>
            <li><a href="/contact/">Обратная связь</a></li>
          </ul>
          <form action="/login/" class="pull-right">
            <input class="input-small" type="text" placeholder="Логин">
            <input class="input-small" type="password" placeholder="Пароль">
            <button class="btn" type="submit">Войти</button>
          </form>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="content">
        <div class="page-header">
            <h1>{{ title }} <small>{{ description }}</small></h1>
        </div>
        {% block content %}{% endblock %}
      </div>

      <footer>
        <p>&copy; Nergal 2011</p>
      </footer>

    </div>

  </body>
</html>

