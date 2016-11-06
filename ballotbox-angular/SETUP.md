#if you're on ubuntu, update your nodejs from this repo
curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
sudo apt-get install nodejs
#NPM has weird permissions if installing in the default directory
#Might also want to make a local directory for npm like so:
mkdir ~/.npm-global
npm config set prefix '~/.npm-global'
nano -w ~/.profile #bottom of file:
    export PATH=~/.npm-global/bin:$PATH
source ~/.profile
#update npm to latest
npm install npm@latest -g
#these 2 commands only needed when updating angular-cli
npm uninstall -g angular-cli
npm cache clean
#install angular-cli
npm install -g angular-cli@latest

#now, in the ballotbox-angular directory install all dependencies
npm install
#you can now build the files with
./build.sh
#they will appear in /web