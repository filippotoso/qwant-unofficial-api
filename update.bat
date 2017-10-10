@echo off
git status
PAUSE
git add .
git status
SET /P MESSAGE=Please enter the commit message: 
IF "%MESSAGE%"=="" GOTO Error
git tag
SET /P VERSION=Please enter the version number: 
IF "%VERSION%"=="" GOTO Error
git commit -m "%MESSAGE%"
git tag -a v%VERSION% -m "%MESSAGE%"
git push origin master --tags
ECHO Done!
GOTO End
:Error1
ECHO You did not enter the message!
GOTO End
:Error1
ECHO You did not enter the version!
GOTO End
:End