import './dashboardPage.scss';
import React, {useEffect, useState} from 'react';
import {useDispatch} from "react-redux";
import {login, logout} from "../features/user/userSlice";
import SidebarDashboard from "../components/dashboard/SidebarDashboard";
import Dashboard from "../components/dashboard/Dashboard";

function DashboardPage({user}) {
    const [activeSidebar, setActiveSidebar] = useState(false);
    const dispatch = useDispatch();

    useEffect(() => {
        console.log(user)
        if (!user) {
            dispatch(logout);
        }
        dispatch(login(user))
    }, [user])
    return (
        <div className="dashboard__page">
            <SidebarDashboard activeSidebar={activeSidebar}/>
            <Dashboard activeSidebar={activeSidebar} setActiveSidebar={setActiveSidebar}/>
        </div>
    )

}

export default DashboardPage;