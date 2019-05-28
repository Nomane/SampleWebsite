
<powershell>
Set-ExecutionPolicy Unrestricted -Force
New-Item -ItemType Directory -Path "c:\temp"
$output="c:\temp\git.exe"
$awscli="c:\temp\awscli.msi"
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
iwr -uri https://github.com/git-for-windows/git/releases/download/v2.21.0.windows.1/Git-2.21.0-64-bit.exe -outfile $output
Start-Process -FilePath $output -ArgumentList /VERYSILENT -Wait
cd "c:\temp"
$env:Path = [System.Environment]::GetEnvironmentVariable("Path","Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path","User")
git clone https://github.com/Guimove/SampleWebsite.git web
Copy-Item "c:\temp\web\*" -Destination "C:\inetpub\wwwroot" -Recurse -force
iwr -uri https://s3.amazonaws.com/aws-cli/AWSCLI64PY3.msi -outfile $awscli
Start-Process -FilePath $awscli -ArgumentList /qn -Wait
$env:Path = [System.Environment]::GetEnvironmentVariable("Path","Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path","User")
$instanceid=(curl http://169.254.169.254/latest/meta-data/instance-id -usebasicparsing).Content
aws ec2 create-tags --region eu-west-1 --resources $instanceid --tags Key=output,Value=Success
</powershell>