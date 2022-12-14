import Link from "../../components/Link";

export default function Default() {
  return (
    <div className="bg-white p-2 max-w-lg flex-grow rounded-sm shadow-2xl">
      <h1 className="text-3xl text-gray-900 font-semibold tracking-normal font-lato">
        Select a user role to login
      </h1>
      <div className="space-y-2 font-sans mt-2">
        <p>
          Login as <Link to="/login/student">student</Link>
        </p>
        <p>
          Login as <Link to="/login/parent">parent</Link>
        </p>
        <p>
          Login as <Link to="/login/librarian">librarian</Link>
        </p>
        <p>
          Login as <Link to="/login/accountant">accountant</Link>
        </p>
        <p>
          Login as <Link to="/login/admin">admin</Link>
        </p>
        <p>
          Login as <Link to="/login/super-admin">super-admin</Link>
        </p>
      </div>
    </div>
  );
}
