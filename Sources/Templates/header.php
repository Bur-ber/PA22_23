<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel = "icon" href ="../../Resources/images/Logo-LE.gif" type = "image/x-icon">
        <title>
          Livry Escalade
        </title>
        <meta name="description" content="site de vie du club de Livry-Gargan">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="CSS/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alkatra&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
            <!-- titre du club, barre de recherche de post (?), liens vers différentes pages :
            inscription/connexion, contact, voir sur d'autres sites -->
            <div class="row b4-head">
              <a class="col-md-2" href="index.php"> <img src="Supplies/Logo-LE.gif" id="Logo" alt="Logo club Livry Escalade"> </a>

              <!-- Barre de recherche -->
              <form class="col-md-4 d-flex" role="search">
                <input class="form-control me-3" type="search" aria-label="Search">
              </form>


              <div class="col-md-6">

              <!-- Logo Mail -->
              <a href="mail.php" class="icon-link">
                <svg width="95" height="95" viewBox="0 0 95 95" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="47.5" cy="47.5" r="47.5" fill="#006F9A"/>
                  <rect x="15.5" y="24.5" width="64" height="46" rx="8.5" fill="white" stroke="#006F9A" stroke-width="3"/>
                  <path d="M23 31L44.5373 51.6758C46.4722 53.5333 49.5278 53.5333 51.4627 51.6758L73 31" stroke="#006F9A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </a>

              <!-- Logo Shop -->
              <a href="shop.php" class="icon-link">
                <svg width="95" height="95" viewBox="0 0 95 95" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="47.5" cy="47.5" r="47.5" fill="#006F9A"/>
                  <path d="M13.6049 45.0721C11.4136 39.8033 15.2852 34 20.9916 34H74.0084C79.7148 34 83.5864 39.8033 81.3951 45.0721L70.1657 72.0721C68.9247 75.0558 66.0105 77 62.779 77H32.221C28.9895 77 26.0753 75.0559 24.8343 72.0721L13.6049 45.0721Z" fill="white"/>
                  <path d="M67 36C67 33.5049 66.5085 31.0342 65.5537 28.729C64.5989 26.4238 63.1993 24.3293 61.435 22.565C59.6707 20.8007 57.5762 19.4011 55.271 18.4463C52.9658 17.4914 50.4951 17 48 17C45.5049 17 43.0342 17.4914 40.729 18.4463C38.4238 19.4011 36.3293 20.8007 34.565 22.565C32.8007 24.3293 31.4011 26.4238 30.4463 28.729C29.4914 31.0342 29 33.5049 29 36H34.1695C34.1695 34.1838 34.5272 32.3853 35.2223 30.7073C35.9173 29.0293 36.9361 27.5046 38.2203 26.2203C39.5046 24.9361 41.0293 23.9173 42.7073 23.2223C44.3853 22.5272 46.1837 22.1695 48 22.1695C49.8163 22.1695 51.6147 22.5272 53.2927 23.2223C54.9707 23.9173 56.4954 24.9361 57.7797 26.2203C59.0639 27.5046 60.0827 29.0293 60.7777 30.7073C61.4728 32.3853 61.8305 34.1837 61.8305 36H67Z" fill="white"/>
                </svg>
              </a>

              <!-- Logo Profil -->
              <a href="compte.php" class="icon-link">
                <svg width="95" height="103" viewBox="0 0 95 103" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="47.5" cy="47.5" r="47.5" fill="#006F9A"/>
                  <ellipse cx="48.426" cy="29.3718" rx="14.3519" ry="15.4487" fill="white"/>
                  <path d="M76.8519 72.6794C76.8519 64.6379 73.857 56.9258 68.5261 51.2396C63.1952 45.5534 55.965 42.3589 48.4259 42.3589C40.8869 42.3589 33.6567 45.5534 28.3258 51.2396C22.9949 56.9258 20 64.6379 20 72.6794L48.4259 72.6794H76.8519Z" fill="white"/>
                </svg>
              </a>
            </div>

            </div>

            <!-- Menu Borgir -->
            <nav>
              <a href="index.php" class="link-nav-h">Accueil</a>
              <?php if(isConnected()){ ?>

			          <a class="nav-link" href="logout.php">Se deconnecter</a>

  		        <?php } else { ?>

  			          <a class="nav-link" href="register.php">S'inscrire</a>
  			          <a class="nav-link" href="login.php">Se connecter</a>

  		        <?php } ?>
              <a href="event.php" class="link-nav-h">Événements</a>
              <a href="forum.php" class="link-nav-h">Forum</a>
            </nav>
        </header>
