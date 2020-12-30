# auth

Ushio User System

[简体中文（推荐）](./zh.md)

## Implementation

There are three concepts in the Ushio user system, namely hash, token and mask.

Each user has a unique hash, which represents all the permissions of this user. If the hash is leaked, the user needs to refresh the hash manually. But this will cause all devices and services previously bound to this user to automatically log out.

Each device (such as a browser) has a unique token. Various services (such as different websites) running on the device each have their own unique mask.

For security, the token is stored in a cookie under auth.yimian.xyz. Every time a user opens a new website, the system will determine and automatically bind the mask to the token. At this time, multiple masks correspond to one token. As shown below

```
     token
    /  |  \
mask1 mask2 mask3
```

Every time a user logs in or registers, what the system does is to associate the token with the hash on the server side. When the user logs out, the token and hash on the server side will be disconnected, and the user will log out.

```
        hash
    /    |    \
token1 token2 token3
```

## Login logic

Taking into account that it is difficult for us to remember the password for a long time, the login logic of this site is designed to log in with an email or mobile number verification code. After logging in, the system will evaluate the user's equipment security according to the changes of fp and ip. If the system assessment result is dangerous, the user will be required to verify, otherwise the user will remain logged in.


## Dependence

Ushio user systems rely heavily on ushio-session, fp, ip and other projects.
