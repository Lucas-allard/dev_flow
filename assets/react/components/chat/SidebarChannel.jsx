import React from 'react';
import './sidebarChannel.scss'

const SidebarChannel = ({onHandleChangeChannel, channelName, sender, handleSelectPrivateMessage, id}) => {
    return (
        <div
            className="sidebarChannel"
            onClick={() => {
                channelName ?
                    onHandleChangeChannel(channelName, id)
                    : handleSelectPrivateMessage(sender, id);
            }}
        >
            <h4>
                <span className="sidebarChannel__hash">#</span>{channelName || sender}
            </h4>
        </div>
    );
}

export default SidebarChannel;