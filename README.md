<a name="readme-top"></a>

[![Forks][forks-shield]][forks-url]
[![Issues][issues-shield]][issues-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://www.github.com/AhmedSobhy01/instagram-clone">
    <img src="https://cdn-icons-png.flaticon.com/512/87/87390.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center">Vistagram</h3>

  <p align="center">
    A replicate of the official Instagram website with the ability to post images for the web application.
    <br />
    <a href="https://vistagram.ahmedsobhy.net">View Demo</a>
    ·
    <a href="https://www.github.com/AhmedSobhy01/instagram-clone/issues">Report Bug</a>
    ·
    <a href="https://www.github.com/AhmedSobhy01/instagram-clone/issues">Request Feature</a>
  </p>
</div>

<!-- ABOUT THE PROJECT -->

## About The Project

[![Product Name Screen Shot][product-screenshot]](https://vistagram.ahmedsobhy.net)

A Laravel project that replicates the official Instagram website is a web application that provides similar functionalities as the original Instagram platform. It allows users to create a profile, post pictures and videos, follow other users, like and comment on posts, and view a feed of posts from users they follow. The project makes use of the Laravel framework to build a robust and scalable web application with features like authentication, user management, media upload and storage, and a dynamic feed system. Additionally, it follows the design and user interface of the official Instagram website to provide a familiar experience to users.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

### Built With

-   [![Laravel][laravel.com]][laravel-url]
-   [![Vue][vue.js]][vue-url]
-   [![Bootstrap][bootstrap.com]][bootstrap-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- Installation -->

### Installation

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

1. Clone the repo
    ```sh
    git clone https://www.github.com/AhmedSobhy01/instagram-clone.git
    ```
2. Install Composer packages
    ```sh
    composer install
    ```
3. Install NPM packages
    ```sh
    npm install
    ```
4. Copy .env.example and then edit .env
    ```sh
    cp .env.example .env
    ```
5. Generate app encryption key
    ```sh
    php artisan key:generate
    ```
6. Migrate and seed the database
    ```sh
    php artisan migrate:fresh --seed
    ```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- USAGE EXAMPLES -->

## Usage

After seeding database, you can login using default user:
| **Email** | **Password** |
| --- | --- |
| test@test.com | password |

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- CONTACT -->

## Contact

Ahmed Sobhy - contact@ahmedsobhy.net

Project Link: [https://www.github.com/AhmedSobhy01/instagram-clone](https://www.github.com/AhmedSobhy01/instagram-clone)

<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- MARKDOWN LINKS & IMAGES -->

[forks-shield]: https://img.shields.io/github/forks/AhmedSobhy01/instagram-clone.svg?style=for-the-badge
[forks-url]: https://github.com/AhmedSobhy01/instagram-clone/network/members
[stars-shield]: https://img.shields.io/github/stars/AhmedSobhy01/instagram-clone.svg?style=for-the-badge
[stars-url]: https://www.github.com/AhmedSobhy01/instagram-clone/stargazers
[issues-shield]: https://img.shields.io/github/issues/AhmedSobhy01/instagram-clone.svg?style=for-the-badge
[issues-url]: https://www.github.com/AhmedSobhy01/instagram-clone/issues
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/ahmed-sobhy-dev
[product-screenshot]: https://ahmedsobhy.net/storage/a93a26d2acfa6c515419674ddfd56f2f/Main-page.png
[vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[vue-url]: https://vuejs.org/
[laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[laravel-url]: https://laravel.com
[bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[bootstrap-url]: https://getbootstrap.com
