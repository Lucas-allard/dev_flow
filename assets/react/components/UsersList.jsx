import './usersList.scss';
import React, {useMemo, useState} from 'react';
import {useDispatch, useSelector} from "react-redux";
import {chooseUserProfil, selectUserProfil, selectUsers} from "../features/user/userSlice";
import Avatar from "@mui/material/Avatar";
import ProfilCard from "./ProfilCard";

function UsersList() {
    const users = useSelector(selectUsers);
    const selectedUser = useSelector(selectUserProfil)
    const dispatch = useDispatch()
    const [isActiveProfilCard, setIsActiveProfilCard] = useState(false);

    const sortUsers = useMemo(() => {
        return users?.slice().sort((a, b) => {
            if (a.isConnected === b.isConnected) {
                return 0;
            }
            return a.isConnected ? -1 : 1;
        });
    }, [users]);


    const handleSelectUser = (user) => {
        dispatch(chooseUserProfil(user))
        setIsActiveProfilCard(true)
    }

    return (
        <div className="users__chat">
            <ul className="users__list">
                {users && sortUsers.map((user, index) =>
                    <li className="users__listItem" key={index} onClick={() => handleSelectUser(user)}>
                        <span className={user.isConnected ? "connected" : ""}></span>
                        {user.profilPicture ?
                            <span>
                            <Avatar alt="profil picture" src={user.profilPicture}/>
                        </span>
                            :
                            <span className="sidebar__avatar">
                            <p>{user.fullname[0].toUpperCase()}</p>
                        </span>
                        }
                        <span>{user.fullname}</span>
                    </li>
                )}
            </ul>
            {isActiveProfilCard &&
                <ProfilCard userProfil={selectedUser} setIsActiveProfilCard={setIsActiveProfilCard}/>

            }
        </div>
    );
}

export default UsersList;