import React from 'react';
import './sidebar.scss'
import AddIcon from '@mui/icons-material/Add';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';

function Sidebar() {
    return (
        <div className="sidebar">
            <div className="sidebar__top">
                <ExpandMoreIcon/>

                <AddIcon/>
            </div>
        </div>
    );
}

export default Sidebar;