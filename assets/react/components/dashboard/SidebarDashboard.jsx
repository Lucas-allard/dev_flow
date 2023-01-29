import './sidebarDashboard.scss';
import React from 'react';
import {useDispatch, useSelector} from "react-redux";
import {selectUser} from "../../features/user/userSlice";
import {selectRoute, setRoute} from "../../features/dashboard/dashboardSlice";

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
                    <li
                        className={`sidebar__navItem ${selectedRoute === "Profil" ? 'active' : ''}`}
                        onClick={() => handleSelectRoute("Profil")}
                    >
                        <button>Profil</button>
                    </li>
                    <li
                        className={`sidebar__navItem ${selectedRoute === "Cours" ? 'active' : ''}`}
                        onClick={() => handleSelectRoute("Cours")}
                    >
                        <button>Cours</button>
                    </li>
                    <li
                        className={`sidebar__navItem ${selectedRoute  === "Challenges" ? 'active' : ''}`}
                        onClick={() => handleSelectRoute("Challenges")}
                    >
                        <button>Challenges</button>
                    </li>
                    <li
                        className={`sidebar__navItem ${selectedRoute  === "Classement" ? 'active' : ''}`}
                        onClick={() => handleSelectRoute("Classement")}
                    >
                        <button>Classement</button>
                    </li>
                    <li
                        className={`sidebar__navItem ${selectedRoute  === "Trophées" ? 'active' : ''}`}
                        onClick={() => handleSelectRoute("Trophées")}
                    >
                        <button>Trophées</button>
                    </li>
                </ul>
            </nav>
        </div>
    );
}

export default SidebarDashboard;