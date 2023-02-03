import "./dashboard.scss";
import React from 'react';
import {useSelector} from "react-redux";
import {selectRoute} from "../../features/dashboard/dashboardSlice";
import DashboardProfile from "./DashboardProfile";

function Dashboard({activeSidebar, setActiveSidebar}) {
    const selectedRoute = useSelector(selectRoute);

    return (
        <section className="dashboard">
            <div className="dashboard__sidebarToggler">
                <button onClick={() => setActiveSidebar(!activeSidebar)}>
                    &#9776;
                </button>
            </div>
            <div className="dashboard__header">
                <h2>{selectedRoute}</h2>
            </div>
            <div className="dashboard__content">
                {selectedRoute === "Profil" && <DashboardProfile/>}
            </div>

        </section>
    );
}

export default Dashboard;