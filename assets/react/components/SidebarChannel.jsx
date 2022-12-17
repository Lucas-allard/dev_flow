import React from 'react';
import './sidebarChannel.scss'

const SidebarChannel = ({onHandleChangeChannel, channelName, id}) => {

    return (
        <div className="sidebarChannel" onClick={() => onHandleChangeChannel(channelName, id)}>
            <h4>
                <span className="sidebarChannel__hash">#</span>{channelName}
            </h4>
        </div>
    );
}

export default SidebarChannel;