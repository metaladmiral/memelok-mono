# Memelok

Memelok is a social media website designed exclusively for memers. It offers a unique feature that provides full copyright ownership to the creators of memes. As a memer, you have complete control over your creations and can protect them from unauthorized use. Memelok also offers various additional features to enhance your memeing experience.

# Features
* Full Copyright Ownership : Memelok ensures that you, as a memer, retain full copyright ownership of the memes you create. This allows you to protect your work and have control over its usage.

* Real-time Chat: Stay connected with your friends and fellow memers through real-time chat. Engage in conversations, share memes, and collaborate on projects in a seamless and interactive environment.

* Personalized Recommendations: Memelok provides personalized recommendations based on your interests and preferences. Discover new memes, trends, and memers that align with your tastes, ensuring an engaging and tailored experience.

* Meme Downloads: Easily download your favorite memes directly from Memelok. Save and enjoy them offline, or share them across other platforms.

* Explore and Discover: Discover a vast collection of memes from memers around the world. Explore trending content, popular memes, and stay up to date with the latest memeverse trends.

* Community Interaction: Join a vibrant community of memers and engage in discussions, collaborations, and sharing of ideas. Connect with like-minded individuals who appreciate the art of memes.

# How to setup locally to contribute?

1. Download and install Xampp server from here - [Click here](https://webwerks.dl.sourceforge.net/project/xampp/XAMPP%20Windows/8.0.28/xampp-windows-x64-8.0.28-0-VS16-installer.exe)
2. Clone this repo in {{XAMPP_INSTALLATION_DIR}}/htdocs/
3. Run the apache and mysql server using Xampp.
4. Now go to {{XAMPP_INSTALLATION_DIR}}/htdocs/memelok-mono/chat-server/ . You can start the chat-dev-server from this dir by running the following command in the terminal:
   ```
   npm install
   npm run devStart
   ```

5. Now go to {{XAMPP_INSTALLATION_DIR}}/htdocs/memelok-mono/image-alteration-server/ . You can start the flask-image-compression dev-server from this dir by runninng the following commands:
  ```
  python3 app.py
  ```

6. Now go to http://localhost:{APACHE_PORT}/phpmyadmin/ and in the import tab, select a file called
   > [memelok_init_DB.sql](DB/memelok_init_DB.sql)
and import the DB.

7. Now, open the [define.php](main/src/actions/define.php) file and set the values of all variables like paths and mysql username and password.

8. Now go to http://localhost:{APACHE_PORT}/memelok-mono to access the website.
