import React, {FunctionComponent, ReactElement} from 'react';
import './sidebarChannels.scss';
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import AddIcon from "@mui/icons-material/Add";

type Props = {
    channelsHeading: string
    children: ReactElement
}

const SidebarChannels: FunctionComponent<Props> = ({channelsHeading, children}) => {
    return (
        <div className="sidebar__channels">
            <div className="sidebar__channelsHeader">
                <div className="sidebar__header">
                    <ExpandMoreIcon/>
                    <h4>{channelsHeading}</h4>
                </div>
                <AddIcon className="sidebar__addChannel"/>
            </div>

            {children}
        </div>
    );
}

export default SidebarChannels;