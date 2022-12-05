import EmailInput from "../../components/input/EmailInput";
import Label from "../../components/input/Label";
import TextInput from "../../components/input/TextInput";
import PasswordInput from "../../components/input/PasswordInput";
import Button from "../../components/button/Button";

export default function CreateSuperUser() {
  return (
    <div className="bg-white max-w-lg flex-grow rounded-sm shadow-2xl box-content px-4">
      <div className="p-2"></div>
      <h1 className="text-3xl text-gray-900 font-semibold tracking-normal">
        Create super user
      </h1>
      <div className="p-2"></div>
      <Label>Enter name</Label>
      <TextInput />
      <div className="p-2"></div>
      <Label>Enter email</Label>
      <EmailInput />
      <div className="p-2"></div>
      <Label>Enter password</Label>
      <PasswordInput />
      <div className="p-2"></div>
      <Label>Confirm password</Label>
      <PasswordInput />
      <div className="p-3"></div>
      <Button>Create user</Button>
      <div className="p-2"></div>
    </div>
  );
}
