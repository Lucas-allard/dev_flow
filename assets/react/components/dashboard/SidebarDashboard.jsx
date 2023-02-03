import './sidebarDashboard.scss';
import React from 'react';
import {useDispatch, useSelector} from "react-redux";
import {selectUser} from "../../features/user/userSlice";
import {selectRoute, setRoute} from "../../features/dashboard/dashboardSlice";
import {navItems} from "../../constants/navItems";

function SidebarDashboard({activeSidebar}) {
    const dispatch = useDispatch();
    const user = useSelector(selectUser);
    const selectedRoute = useSelector(selectRoute)


    const handleSelectRoute = (route) => {
        dispatch(setRoute(route))
    }

    return (
        <div className={`sidebar__dashboard ${activeSidebar ? "active" : ""}`}>
            <div className="sidebar__header">
                <h2>Dashboard</h2>
                {user && user?.profilPicture ?
                    <img className="sidebar__avatar" alt="profil picture" src={user.profilPicture}/>
                    :
                    <div className="sidebar__avatar">
                        <p>{user?.fullName[0].toUpperCase()}</p>
                    </div>
                }
                <div className="sidebar__dashboardInfo">
                    <h3>{user?.fullName}</h3>
                    <p>#{user?.googleId.substring(0, 8)}</p>
                </div>

            </div>
            <hr/>
            <nav className="sidebar__nav">
                <ul>
                    {navItems.map((item, index) =>
                        <li
                            className={`sidebar__navItem ${selectedRoute === item.route ? 'active' : ''}`}
                            onClick={() => handleSelectRoute(item.route)}
                            key={index}
                        >
                            <button>{item.route}</button>
                        </li>
                    )}
                </ul>
            </nav>
        </div>
    );
}

export default SidebarDashboard;