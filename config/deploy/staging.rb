############################################
# Setup Server
############################################

set :user, "joshuajohnson.co.uk"
set :host, "s156312.gridserver.com"
set :password, "cheeseball27"
server "#{host}", :app
set :deploy_to, "/domains/connectd.io/html/site"

############################################
# Setup Git
############################################

set :branch, "development"