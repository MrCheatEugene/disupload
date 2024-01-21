# disupload
File sharing service that uses Discord AS storage!

# Installation
1. Clone [PHPMailer](https://github.com/PHPMailer/PHPMailer), and copy "src" to "phpmailer" folder in your website folder.
2. Clone this repo to your website folder.
3. Configure DB connection in functions.php, and E-mail connection in email.php (the last isn't required, only if you want for "Send email" button to work)
4. Configure discord webhook in functions.php. (the most important part!)
5. Get your new password hash, using password_hash function in PHP and some online PHP compiler, or just do it on the server.
6. Import the DB structure from disupload.sql
7. Insert your password hash into "passwd" field of "auth" database
8. You're done.

# Using
1. Go to your website, and log in with your previously-set password.
2. Upload files
3. ???
4. Done.

# Inspiration
Project was inspired from ["Stealing storage from Discord"](https://www.youtube.com/watch?v=c_arQ-6ElYI) video, by Dev Detour.

And actually inspired, by this statement:
> - Will I release the code? Definitely no. As I mention in the video this was a fun experiment/proof of concept, but to be clear: you shouldn't do this yourself, this is not a serious alternative to real cloud storage.

But who listens to "Don't do this at home" labels? Not me.

So, here's my attempt to re-create the project in the video, using PHP!
I could use some better languages, like C# (asp.net), JS (express.js), or Python (Django). But, I was making it for myself at the start, so I used a language I am the most familiar with.

# License
This code is released by MIT license, and includes using [this E-mail template](https://github.com/leemunroe/responsive-html-email-template) which is using MIT license also.
PHPMailer is licensed by LGPL-2.1 license.

# Any questions?
Contact me on discord (objectpromise), or in [Telegram](https://t.me/Pomorgite).
