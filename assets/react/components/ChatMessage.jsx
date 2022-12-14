import React from 'react';
import "./chatMessage.scss"
import Avatar from '@mui/material/Avatar';
import {htmlSpecialDecode} from "../utils/htmlSpecialDecode";


const ChatMessage = ({userPicture, fullname, timestamp, message}) => {
    return (
        <div className="message">
            {userPicture ?
                <Avatar alt="profil picture" src={userPicture}/>
                :
                <div className="sidebar__avatar">
                    <p>{fullname[0].toUpperCase()}</p>
                </div>
            }

            <div className="message__info">
                <h4>
                    {fullname}
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