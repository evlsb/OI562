@echo Off
SetLocal EnableExtensions
Set ProcessName=php.exe 
Set ProcessPath="C:\reportsOI562\php\php.exe" 
Set WebPath="C:\reportsOI562\WEB\DocViewer\"
Set /A CountReload=3
 
cd /c !WebPath!
GOTO exist

:exist
IF %CountReload% NEQ 0 (
	TaskList /FI "ImageName EQ %ProcessName%" | Find /I "%ProcessName%"
	If %ErrorLevel% NEQ 0  (
		GOTO start
	) ELSE (
		GOTO close
	)
)
EXIT /B 1

:close
taskkill /F /im %ProcessName% 
Set /A CurrReload=0
GOTO exist 
GOTO end
EXIT /B 1

:start
%ProcessPath% -S 127.0.0.1:8011 
GOTO end
EXIT /B 1


:end 