import './dashboardPage.scss';
import React, { useState} from 'react';
import SidebarDashboard from "../components/dashboard/SidebarDashboard";
import Dashboard from "../components/dashboard/Dashboard";
import {ToastContainer} from "react-toastify";

function DashboardPage() {
    const [activeSidebar, setActiveSidebar] = useState(false);

    return (
        <div className="dashboard__page">
            <SidebarDashboard activeSidebar={activeSidebar}/>
            <Dashboard activeSidebar={activeSidebar} setActiveSidebar={setActiveSidebar}/>
            <ToastContainer/>
        </div>
    )

}

export default DashboardPage;