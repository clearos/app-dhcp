
Name: app-dhcp
Epoch: 1
Version: 1.6.5
Release: 1%{dist}
Summary: DHCP Server
License: GPLv3
Group: ClearOS/Apps
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base
Requires: app-network

%description
The DHCP Server app provides automatic IP configuration to devices on your network.

%package core
Summary: DHCP Server - Core
License: LGPLv3
Group: ClearOS/Libraries
Requires: app-base-core
Requires: app-network-core
Requires: dnsmasq >= 2.48

%description core
The DHCP Server app provides automatic IP configuration to devices on your network.

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/dhcp
cp -r * %{buildroot}/usr/clearos/apps/dhcp/


%post
logger -p local6.notice -t installer 'app-dhcp - installing'

%post core
logger -p local6.notice -t installer 'app-dhcp-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/dhcp/deploy/install ] && /usr/clearos/apps/dhcp/deploy/install
fi

[ -x /usr/clearos/apps/dhcp/deploy/upgrade ] && /usr/clearos/apps/dhcp/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-dhcp - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-dhcp-core - uninstalling'
    [ -x /usr/clearos/apps/dhcp/deploy/uninstall ] && /usr/clearos/apps/dhcp/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/dhcp/controllers
/usr/clearos/apps/dhcp/htdocs
/usr/clearos/apps/dhcp/views

%files core
%defattr(-,root,root)
%exclude /usr/clearos/apps/dhcp/packaging
%dir /usr/clearos/apps/dhcp
/usr/clearos/apps/dhcp/deploy
/usr/clearos/apps/dhcp/language
/usr/clearos/apps/dhcp/libraries
