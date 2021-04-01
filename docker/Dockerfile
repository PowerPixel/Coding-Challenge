FROM mysql:5.7
WORKDIR /usr/src/coding-challenge
# Fix pour TZData
ENV TZ=Europe/Paris
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt update
RUN apt install -y php php-xsl git curl wget php-mysql php-curl virtualbox-6.1
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN mkdir -p /home/root
RUN phpenmod xsl
RUN phpenmod pdo_mysql
RUN phpenmod curl
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir /usr/bin --filename composer
RUN php -r "unlink('composer-setup.php');"
RUN usermod -d /var/lib/mysql/ mysql
RUN export HOME='/home/root'
COPY startCodingChallengeDocker.sh /usr/bin/startCodingChallengeDocker
RUN chmod +x /usr/bin/startCodingChallengeDocker