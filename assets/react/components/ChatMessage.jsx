import React from 'react';
import "./chatMessage.scss"
import Avatar from '@mui/material/Avatar';


const ChatMessage = ({userPicture, fullname, timestamp, message}) => {
    return (
        <div className="message">
            <Avatar src={userPicture}/>

            <div className="message__info">
                <h4>
                    {fullname}
                    <span className="message__timestamp">{timestamp}</span>
                </h4>
                <p>{message}</p>
            </div>
        </div>
    );
}

export default ChatMessage;