import React from 'react';
import "./chatMessage.scss"
import Avatar from '@mui/material/Avatar';
import {htmlSpecialDecode} from "../../utils/htmlSpecialDecode";


const ChatMessage = ({userPicture, fullName, timestamp, message}) => {
    return (
        <div className="message">
            {userPicture ?
                <Avatar alt="profil picture" src={userPicture}/>
                :
                <div className="sidebar__avatar">
                    <p>{fullName[0].toUpperCase()}</p>
                </div>
            }

            <div className="message__info">
                <h4>
                    {fullName}
                    <span className="message__timestamp">{timestamp}</span>
                </h4>
                <p
                    dangerouslySetInnerHTML={{__html: htmlSpecialDecode(message)}}
                />
            </div>
        </div>
    );
}

export default ChatMessage;