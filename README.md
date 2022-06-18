# @HubMembersMod
### The Original Automated SMF AirDC++ Web Client Hub Members Mod
  
## About
Hub Members Mod, or HMM is The Original Automated SMF AirDC++ Web Client Hub Members Mod, which automates membership syncronization between your SMF web site and your hub, using an airdcpp-webclient and a set of PHP integration functions.  
  
## Installation
First, install the HubMembersMod package to your SMF forum.  
  
Next, make sure your AirDC++ Web Client user has the proper priviledges to perform the membership syncronization on your hub.  
  
Next, edit the `HubMembersMod.php` file, replacing the values for the following variables:  
  
```
$strWebclientUser = "adminUser";
$strWebclientPass = "adminPass";
$strWebclientAddress = "https://127.0.0.1:5601";
$strHubAddress = "adcs://127.0.0.1:5300/?kp=SHA256/XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
$boolHubMembersModEnabled = false;
```
  
There is no user interface. If you would like to create a user interface for this mod package, please feel free to open a GitHub Pull Request.  
  
The `integrate_delete_member` hook is commented out because of a logical error in the SMF `integrate_register` and `integrate_delete_member` hooks.  
  
Sadly, SMF does not provide any hook for changing, maintaining or syncronizing the identity (user nick only) of the user.  
  
## Contributing
Let's work better together. We are looking to collaborate with like-minded people who want to contribute in any capacity. Collaboration is open to everyone and we need your help if you are a:  
- Developer
- Graphic Artist
- Linguist/Translator
- Tester
  
Feel free to:  
- Fork the repository
- Branch your repository with a meaningful name related to the changes you are making
- Create a pull request
  
## Contact
GitHub: [https://github.com/TwistedTommy/HubMembersMod](https://github.com/TwistedTommy/HubMembersMod "GitHub")  
  
---
###### Copyright (c) 2022 HubMembersMod - All Rights Reserved v2022-06-16-00
