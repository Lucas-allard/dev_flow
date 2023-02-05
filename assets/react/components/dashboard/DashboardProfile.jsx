import './dashboardProfile.scss';
import React, {useEffect, useState} from 'react';
import {useDispatch, useSelector} from "react-redux";
import { selectUser, updateUserData, updateUserPicture} from "../../features/user/userSlice";
import {useForm} from "react-hook-form";
import InputBox from "../commons/InputBox";
import TextareaBox from "../commons/TextareaBox";
import {toast} from "react-toastify";

function DashboardProfile() {
    const user = useSelector(selectUser)
    const {register, handleSubmit, setValue} = useForm();
    const dispatch = useDispatch();
    const [errors, setErrors] = useState([]);

    const notify = (type, message) => toast(message, {
        position: "top-right",
        autoClose: 5000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
        theme: "dark",
        type: type
    });


    const userFields = [
        {
            type: "text",
            name: "fullName",
            value: user?.fullName,
            label: "Nom d'utilisateur",
            register: {...register("fullName")},
        },
        {
            type: "email",
            name: "email",
            value: user?.email,
            label: "Email",
            register: {...register("email")},

        },
        {
            type: "text",
            name: "job",
            value: user?.job,
            label: "Status (Apprenti ou Mentor)",
            register: {...register("job")},

        },
        {
            type: "file",
            name: "file",
            value: user?.profilPicture ?? "",
            label: "Photo de profil",
            register: {...register("file")},
        },
        {
            type: "text",
            name: "city",
            value: user?.city ?? "",
            label: "Ville",
            register: {...register("city")},

        },
        {
            type: "text",
            name: "zipCode",
            value: user?.zipCode ?? "",
            label: "Code postal",
            register: {...register("zipCode")},

        },
        {
            type: "textarea",
            name: "bio",
            value: user?.bio ?? "",
            label: "Mini Bio",
            register: {...register("bio")},
        }
    ]

    useEffect(() => {
        userFields.forEach(field => {
            setValue(field.name, field.value)
        })
    }, [user])

    const onSubmit = async (data) => {
        try {
            let response = await dispatch(updateUserData({data: data, id: user.id})).unwrap();

            if (Array.isArray(data.file)) {
                const formData = new FormData();
                formData.append("file", data.file[0]);
                response = await dispatch(updateUserPicture({data: formData, id: user.id})).unwrap();
            }

            const {status} = response;

            if (status === 200 || status === 201) {
                notify("success", "Votre profil a bien été mis à jour")
                setErrors([])
            }
        } catch (e) {
            if (e.violations) {
                let apiErrors = {};
                e.violations.forEach(violation => {
                    apiErrors[violation.propertyPath] = violation.message
                })
                console.log(apiErrors)
                setErrors(apiErrors)
            }
        }
    }

    return (
        <div className="dashboard__profile">
            <div className="profileContent__header">
                <h3>Edition</h3>
                <p>Modifier votre profil selon vos besoins</p>
            </div>
            <form className="dashboard__profileForm" onSubmit={handleSubmit(onSubmit)}
                  encType="multipart/form-data">
                {userFields.map((field, index) => field.type !== "textarea" ?
                    <InputBox
                        key={index}
                        type={field.type}
                        label={field.label}
                        register={{
                            ...register(field.name)
                        }}
                        error={errors?.[field.name]}
                    />
                    : <TextareaBox
                        key={index}
                        label={field.label}
                        register={{
                            ...register(field.name)
                        }}
                        error={errors?.[field.name]}
                    />
                )}
                <input type="submit" value="Valider"/>
            </form>
        </div>
    );

}

export default DashboardProfile;