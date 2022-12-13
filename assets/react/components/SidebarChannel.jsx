import React from 'react';
import './sidebarChannel.scss'

const SidebarChannel = (props) => {
    return (
        <div className="sidebarChannel">
            <h4>
                <span className="sidebarChannel__hash">#</span>{props.channelName}
            </h4>
        </div>
    );
}

export default SidebarChannel;