Simple Slack Add Ons
=========================

Simple and small integration add ons for Slack.

## stock.php (/stock command)
**Usage:** /stock msft, aapl **or** /stock msft aapl 

## How does slash command integration works?

A slash command triggers a POST To a web URL with information including channel name from which the command originated from, user name requesting the command, full command line (command and parameters in two seperate variables) and also a token to validate if the reqest is comaing from Slack servers. 

The flow is simple: 
* User executest the command by typing the command and parameters in a channel. In this case "/stock gs"
* Slack posts all information to a URL. 
* URL is expected to return a response, or not return anything (but the service can also post to a channel directly if that integration is done, and a POST endpoint is configured on Slack - more on that later). 

### More info
* Slack API: https://api.slack.com
* Create your own integration for slash commands: https://my.slack.com/services/new/slash-commands 
* Message formatting: https://api.slack.com/docs/formatting
